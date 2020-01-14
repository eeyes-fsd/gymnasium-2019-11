/*
 * Academic License - for use in teaching, academic research, and meeting
 * course requirements at degree granting institutions only.  Not for
 * government, commercial, or other organizational use.
 *
 * xgeqp3.cpp
 *
 * Code generation for function 'xgeqp3'
 *
 */

/* Include files */
#include <math.h>
#include "rt_nonfinite.h"
#include "indefinite_solve.h"
#include "xgeqp3.h"
#include "xnrm2.h"
#include "xscal.h"
#include "xswap.h"
#include "indefinite_solve_emxutil.h"

/* Function Declarations */
static double rt_hypotd_snf(double u0, double u1);

/* Function Definitions */
static double rt_hypotd_snf(double u0, double u1)
{
  double y;
  double a;
  double b;
  a = fabs(u0);
  b = fabs(u1);
  if (a < b) {
    a /= b;
    y = b * sqrt(a * a + 1.0);
  } else if (a > b) {
    b /= a;
    y = a * sqrt(b * b + 1.0);
  } else if (rtIsNaN(b)) {
    y = b;
  } else {
    y = a * 1.4142135623730951;
  }

  return y;
}

void xgeqp3(emxArray_real_T *A, double tau_data[], int tau_size[1],
            emxArray_int32_T *jpvt)
{
  int n;
  int mn;
  int b_n;
  int i2;
  int yk;
  emxArray_real_T *work;
  int k;
  emxArray_real_T *vn1;
  emxArray_real_T *vn2;
  int nmi;
  int i;
  double smax;
  double s;
  int i_i;
  double absxk;
  double t;
  int ix;
  int i_ip1;
  int lastv;
  int lastc;
  boolean_T exitg2;
  int exitg1;
  n = A->size[1];
  mn = A->size[1];
  if (3 < mn) {
    mn = 3;
  }

  tau_size[0] = mn;
  if (A->size[1] < 1) {
    b_n = 0;
  } else {
    b_n = A->size[1];
  }

  i2 = jpvt->size[0] * jpvt->size[1];
  jpvt->size[0] = 1;
  jpvt->size[1] = b_n;
  emxEnsureCapacity_int32_T(jpvt, i2);
  if (b_n > 0) {
    jpvt->data[0] = 1;
    yk = 1;
    for (k = 2; k <= b_n; k++) {
      yk++;
      jpvt->data[k - 1] = yk;
    }
  }

  if (A->size[1] != 0) {
    emxInit_real_T1(&work, 1);
    yk = A->size[1];
    i2 = work->size[0];
    work->size[0] = yk;
    emxEnsureCapacity_real_T1(work, i2);
    for (i2 = 0; i2 < yk; i2++) {
      work->data[i2] = 0.0;
    }

    emxInit_real_T1(&vn1, 1);
    emxInit_real_T1(&vn2, 1);
    yk = A->size[1];
    i2 = vn1->size[0];
    vn1->size[0] = yk;
    emxEnsureCapacity_real_T1(vn1, i2);
    i2 = vn2->size[0];
    vn2->size[0] = vn1->size[0];
    emxEnsureCapacity_real_T1(vn2, i2);
    k = 1;
    for (nmi = 0; nmi < n; nmi++) {
      smax = 0.0;
      s = 3.3121686421112381E-170;
      for (yk = k; yk <= k + 2; yk++) {
        absxk = fabs(A->data[yk - 1]);
        if (absxk > s) {
          t = s / absxk;
          smax = 1.0 + smax * t * t;
          s = absxk;
        } else {
          t = absxk / s;
          smax += t * t;
        }
      }

      smax = s * sqrt(smax);
      vn1->data[nmi] = smax;
      vn2->data[nmi] = vn1->data[nmi];
      k += 3;
    }

    for (i = 1; i <= mn; i++) {
      i_i = (i + (i - 1) * 3) - 1;
      nmi = (n - i) + 1;
      if (nmi < 1) {
        yk = 0;
      } else {
        yk = 1;
        if (nmi > 1) {
          ix = i - 1;
          smax = fabs(vn1->data[i - 1]);
          for (k = 2; k <= nmi; k++) {
            ix++;
            s = fabs(vn1->data[ix]);
            if (s > smax) {
              yk = k;
              smax = s;
            }
          }
        }
      }

      yk = (i + yk) - 2;
      if (yk + 1 != i) {
        xswap(A, 1 + 3 * yk, 1 + 3 * (i - 1));
        b_n = jpvt->data[yk];
        jpvt->data[yk] = jpvt->data[i - 1];
        jpvt->data[i - 1] = b_n;
        vn1->data[yk] = vn1->data[i - 1];
        vn2->data[yk] = vn2->data[i - 1];
      }

      if (i < 3) {
        t = A->data[i_i];
        absxk = 0.0;
        smax = xnrm2(3 - i, A, i_i + 2);
        if (smax != 0.0) {
          s = rt_hypotd_snf(A->data[i_i], smax);
          if (A->data[i_i] >= 0.0) {
            s = -s;
          }

          if (fabs(s) < 1.0020841800044864E-292) {
            yk = 0;
            do {
              yk++;
              xscal(3 - i, 9.9792015476736E+291, A, i_i + 2);
              s *= 9.9792015476736E+291;
              t *= 9.9792015476736E+291;
            } while (!(fabs(s) >= 1.0020841800044864E-292));

            s = rt_hypotd_snf(t, xnrm2(3 - i, A, i_i + 2));
            if (t >= 0.0) {
              s = -s;
            }

            absxk = (s - t) / s;
            xscal(3 - i, 1.0 / (t - s), A, i_i + 2);
            for (k = 1; k <= yk; k++) {
              s *= 1.0020841800044864E-292;
            }

            t = s;
          } else {
            absxk = (s - A->data[i_i]) / s;
            smax = 1.0 / (A->data[i_i] - s);
            xscal(3 - i, smax, A, i_i + 2);
            t = s;
          }
        }

        tau_data[i - 1] = absxk;
        A->data[i_i] = t;
      } else {
        tau_data[2] = 0.0;
      }

      if (i < n) {
        t = A->data[i_i];
        A->data[i_i] = 1.0;
        i_ip1 = i + i * 3;
        if (tau_data[i - 1] != 0.0) {
          lastv = 4 - i;
          yk = (i_i - i) + 3;
          while ((lastv > 0) && (A->data[yk] == 0.0)) {
            lastv--;
            yk--;
          }

          lastc = nmi - 1;
          exitg2 = false;
          while ((!exitg2) && (lastc > 0)) {
            yk = i_ip1 + (lastc - 1) * 3;
            nmi = yk;
            do {
              exitg1 = 0;
              if (nmi <= (yk + lastv) - 1) {
                if (A->data[nmi - 1] != 0.0) {
                  exitg1 = 1;
                } else {
                  nmi++;
                }
              } else {
                lastc--;
                exitg1 = 2;
              }
            } while (exitg1 == 0);

            if (exitg1 == 1) {
              exitg2 = true;
            }
          }
        } else {
          lastv = 0;
          lastc = 0;
        }

        if (lastv > 0) {
          if (lastc != 0) {
            for (yk = 1; yk <= lastc; yk++) {
              work->data[yk - 1] = 0.0;
            }

            yk = 0;
            i2 = i_ip1 + 3 * (lastc - 1);
            for (b_n = i_ip1; b_n <= i2; b_n += 3) {
              ix = i_i;
              smax = 0.0;
              k = (b_n + lastv) - 1;
              for (nmi = b_n; nmi <= k; nmi++) {
                smax += A->data[nmi - 1] * A->data[ix];
                ix++;
              }

              work->data[yk] += smax;
              yk++;
            }
          }

          if (!(-tau_data[i - 1] == 0.0)) {
            yk = i_ip1 - 1;
            b_n = 0;
            for (nmi = 1; nmi <= lastc; nmi++) {
              if (work->data[b_n] != 0.0) {
                smax = work->data[b_n] * -tau_data[i - 1];
                ix = i_i;
                i2 = lastv + yk;
                for (k = yk; k < i2; k++) {
                  A->data[k] += A->data[ix] * smax;
                  ix++;
                }
              }

              b_n++;
              yk += 3;
            }
          }
        }

        A->data[i_i] = t;
      }

      for (nmi = i; nmi < n; nmi++) {
        if (vn1->data[nmi] != 0.0) {
          smax = fabs(A->data[(i + A->size[0] * nmi) - 1]) / vn1->data[nmi];
          smax = 1.0 - smax * smax;
          if (smax < 0.0) {
            smax = 0.0;
          }

          s = vn1->data[nmi] / vn2->data[nmi];
          s = smax * (s * s);
          if (s <= 1.4901161193847656E-8) {
            if (i < 3) {
              vn1->data[nmi] = xnrm2(3 - i, A, (i + 3 * nmi) + 1);
              vn2->data[nmi] = vn1->data[nmi];
            } else {
              vn1->data[nmi] = 0.0;
              vn2->data[nmi] = 0.0;
            }
          } else {
            vn1->data[nmi] *= sqrt(smax);
          }
        }
      }
    }

    emxFree_real_T(&vn2);
    emxFree_real_T(&vn1);
    emxFree_real_T(&work);
  }
}

/* End of code generation (xgeqp3.cpp) */
